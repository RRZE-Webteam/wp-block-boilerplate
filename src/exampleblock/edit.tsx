/**
 * Import section
 *
 * All needed components and functions are imported in this section. You can find a
 * list of all available components and functions at https://wordpress.github.io/gutenberg/
 */
import {
  TextControl,
  PanelBody,
  __experimentalText as Text,
  __experimentalSpacer as Spacer,
} from "@wordpress/components";
import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
  BlockControls,
  ContrastChecker,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { useDispatch } from "@wordpress/data";
import { store as blockEditorStore } from "@wordpress/block-editor";
import {
  StandardColorSwitcher,
  StandardColorSwitcherToolbar,
  BorderColorPicker,
} from "../components/CustomColorSwitcher";

/**
 * The TypeScript Props for the Edit Component. To learn more about Props and how to use them in TS,
 * visit https://www.typescriptlang.org/docs/handbook/interfaces.html
 */
interface EditProps {
  attributes: {
    style?: string;
    color: string;
    textColor?: string;
    borderColor?: string;
    title?: string;
  };
  setAttributes: (attributes: Partial<EditProps["attributes"]>) => void;
  clientId: string;
  context: { [key: string]: any };
  blockProps: any;
}

/**
 * The Edit Component – The Brain of the Block
 * @param param0
 * @returns
 */
export default function Edit({
  blockProps,
  attributes,
  setAttributes,
}: EditProps) {
  const props = useBlockProps();

  /**
   * The colorDataAlert array contains the color options for the alert block.
   */
  const colorDataAlert = [
    {
      color: "#e9edf2",
      slug: "default",
      name: __("Default", "wp-block-boilerplate"),
    },
    {
      color: "#dff0d8",
      slug: "success",
      name: __("Success", "wp-block-boilerplate"),
    },
    {
      color: "#d9edf7",
      slug: "info",
      name: __("Info", "wp-block-boilerplate"),
    },
    {
      color: "#fcf8e3",
      slug: "warning",
      name: __("Warning", "wp-block-boilerplate"),
    },
    {
      color: "#f2dede",
      slug: "danger",
      name: __("Danger", "wp-block-boilerplate"),
    },
  ];

  let borderStyle = attributes.borderColor
    ? { border: `1px solid ${attributes.borderColor}` }
    : {};
  if (attributes.style === "example") {
    borderStyle = { border: `1px dashed var(--color-TextLight, #707070)` };
  }

  /**
   * __unstableMarkNextChangeAsNotPersistent is a function that marks the next change as not persistent for the undo and redo state of the Editor.
   * This might be important, if you recognize, that the usage of your block makes reverting back changes via the undo-action inside the editor difficult or impossible.
   * Discussion regarding the Undo Trap: https://github.com/WordPress/gutenberg/issues/8119
   */
  const { __unstableMarkNextChangeAsNotPersistent } =
    useDispatch(blockEditorStore);

  const onChangeTitle = (newText: string) => {
    if (newText === "") {
      __unstableMarkNextChangeAsNotPersistent();
      setAttributes({ title: "", style: "default" });
    } else {
      __unstableMarkNextChangeAsNotPersistent();
      setAttributes({ title: newText, style: "example" });
    }
  };

  /**
   * The Edit Component – The Blocks Structure and Controls
   */
  return (
    <div {...props}>
      {/**
       * The InspectorControls component is the container for block controls that are displayed in the block settings sidebar.
       */}
      <InspectorControls>
        <StandardColorSwitcher
          attributes={{ color: attributes.color }}
          setAttributes={setAttributes}
          colorData={colorDataAlert}
          hex={true}
          useStyle={true}
          customColor={false}
          useTextColor={true}
        />
        {/**
         * The contrast checker outputs a warning, if users color choices are not accessible by using the passed textColor and backgroundColor-Values.
         */}
        <ContrastChecker
          textColor={attributes.textColor}
          backgroundColor={attributes.color}
        />

       {/**
       * If the style attribute is set, the BorderColorPicker is not displayed.
       */}
        {attributes.style ? null : (
          <BorderColorPicker
            attributes={{ color: attributes.borderColor }}
            setAttributes={setAttributes}
          />
        )}
        <PanelBody
          title={__("Label settings", "wp-block-boilerplate")}
          initialOpen={true}
        >
          <Spacer>
            <Text>
              {__(
                "Add a Label for your Alert. This changes the style to example",
                "wp-block-boilerplate"
              )}
            </Text>
          </Spacer>
          <TextControl
            value={attributes.title}
            onChange={onChangeTitle}
            placeholder={__("Add a Label", "wp-block-boilerplate")}
            className="elements-blocks-input-following-icon"
          />
        </PanelBody>
      </InspectorControls>

      {/**
       * Controls the block toolbar. The StandardColorSwitcherToolbar is used to switch between the different color options.
       */}
      <BlockControls>
        <StandardColorSwitcherToolbar
          attributes={{ color: attributes.color, style: attributes.style }}
          setAttributes={setAttributes}
          colorData={colorDataAlert}
          hex={true}
          useStyle={true}
        />
      </BlockControls>

      {/**
       * The HTML structure of the block. The InnerBlocks component is used to allow nested blocks inside the alert block.
       */}
      <div
        className={`alert clearfix clear ${
          attributes.style ? `alert-${attributes.style}` : ""
        }`}
        style={{
          ...(attributes.style
            ? {}
            : {
                backgroundColor: attributes.color,
                color: attributes.textColor,
              }),
          ...borderStyle,
        }}
        title={attributes.title}
      >
        <InnerBlocks
          template={[
            [
              "core/paragraph",
              { placeholder: __("Add a description…", "wp-block-boilerplate") },
            ],
          ]}
          allowedBlocks={["core/paragraph", "core/heading", "core/list"]}
          templateLock={false}
        />
      </div>
    </div>
  );
}
